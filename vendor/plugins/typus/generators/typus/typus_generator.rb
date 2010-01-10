class TypusGenerator < Rails::Generator::Base

  def manifest

    record do |m|

      ##
      # Define variables.
      #

      application = Rails.root.basename
      timestamp = Time.now.utc.strftime("%Y%m%d%H%M%S")

      ##
      # Create required folders.
      #

      [ 'app/controllers/admin', 
        'app/views/admin', 
        'config/typus', 
        'public/images/admin/fancybox', 
        'public/javascripts/admin', 
        'public/stylesheets/admin', 
        'test/functional/admin' ].each { |f| FileUtils.mkdir_p(f) unless File.directory?(f) }

      # To create <tt>application.yml</tt> and <tt>application_roles.yml</tt> 
      # detect available AR models on the application.
      models = (Typus.discover_models + Typus.models).uniq
      ar_models = []

      models.each do |model|
        begin
          klass = model.constantize
          active_record_model = klass.superclass.equal?(ActiveRecord::Base) && !klass.abstract_class?
          active_record_model_with_sti = klass.superclass.superclass.equal?(ActiveRecord::Base)
          ar_models << klass if active_record_model || active_record_model_with_sti
        rescue Exception => error
          puts "=> [typus] #{error.message} on '#{model}'."
          exit
        end
      end

      configuration = { :base => '', :roles => '' }

      ar_models.sort{ |x,y| x.class_name <=> y.class_name }.each do |model|

        next if Typus.models.include?(model.name)

        # Detect all relationships except polymorphic belongs_to using reflection.
        relationships = [ :belongs_to, :has_and_belongs_to_many, :has_many, :has_one ].map do |relationship|
                          model.reflect_on_all_associations(relationship).reject { |i| i.options[:polymorphic] }.map { |i| i.name.to_s }
                        end.flatten.sort

        # Remove foreign key and polymorphic type attributes
        reject_columns = []
        model.reflect_on_all_associations(:belongs_to).each do |i|
          reject_columns << model.columns_hash[i.name.to_s + '_id']
          reject_columns << model.columns_hash[i.name.to_s + '_type'] if i.options[:polymorphic]
        end

        model_columns = model.columns - reject_columns

        ##
        # Model field defaults for:
        #
        # - List
        # - Form
        #

        list_rejections = %w( id created_at created_on updated_at updated_on )
        form_rejections = %w( id created_at created_on updated_at updated_on position )

        list = model_columns.reject { |c| c.sql_type == 'text' || list_rejections.include?(c.name) }.map(&:name)
        form = model_columns.reject { |c| form_rejections.include?(c.name) }.map(&:name)

        ##
        # Model defaults:
        #
        # - Order
        # - Filters
        # - Search
        #

        order_by = 'position' if list.include?('position')
        filters = 'created_at' if model_columns.include?('created_at')
        search = 'name' if list.include?('name')

        # We want attributes of belongs_to relationships to be shown in our 
        # field collections if those are not polymorphic.
        [ list, form ].each do |fields|
          fields << model.reflect_on_all_associations(:belongs_to).reject { |i| i.options[:polymorphic] }.map { |i| i.name.to_s }
          fields.flatten!
        end

        configuration[:base] << <<-RAW
#{model}:
  fields:
    list: #{list.join(', ')}
    form: #{form.join(', ')}
  order_by: #{order_by}
  relationships: #{relationships.join(', ')}
  filters: #{filters}
  search: #{search}
  application: #{application}

        RAW

        configuration[:roles] << <<-RAW
  #{model}: create, read, update, delete
        RAW

      end

      if !configuration[:base].empty?

        [ "application.yml", "application_roles.yml" ].each do |file|
          from = to = "config/typus/#{file}"
          if File.exists?(from) then to = "config/typus/#{timestamp}_#{file}" end
          m.template from, to, :assigns => { :configuration => configuration }
        end

      end

      [ "typus.yml", "typus_roles.yml", "README" ].each do |file|
        from = to = "config/typus/#{file}"
        m.template from, to, :assigns => { :configuration => configuration }
      end

      ##
      # Initializer
      #

      [ 'config/initializers/typus.rb' ].each do |file|
        from = to = file
        m.template from, to, :assigns => { :application => application }
      end

      ##
      # Assets
      #

      [ 'public/images/admin/ui-icons.png' ].each { |f| m.file f, f }

      Dir["#{Typus.root}/generators/typus/templates/public/stylesheets/admin/*"].each do |file|
        from = to = "public/stylesheets/admin/#{File.basename(file)}"
        m.file from, to
      end

      Dir["#{Typus.root}/generators/typus/templates/public/javascripts/admin/*"].each do |file|
        from = to = "public/javascripts/admin/#{File.basename(file)}"
        m.file from, to
      end

      Dir["#{Typus.root}/generators/typus/templates/public/images/admin/fancybox/*"].each do |file|
        from = to = "public/images/admin/fancybox/#{File.basename(file)}"
        m.file from, to
      end

      ##
      # Generate:
      #   `app/controllers/admin/#{resource}_controller.rb`
      #   `test/functional/admin/#{resource}_controller_test.rb`
      #

      ar_models << TypusUser
      ar_models.each do |model|

        folder = "admin/#{model.name.tableize}".split('/')[0...-1].join('/')

        # Create needed folder.
        [ "app/controllers/#{folder}", 
          "test/functional/#{folder}"].each { |f| FileUtils.mkdir_p(f) unless File.directory?(f) }

        m.template "auto/resources_controller.rb.erb", 
                   "app/controllers/admin/#{model.name.tableize}_controller.rb", 
                   :assigns => { :model => model.name }

        m.template "auto/resource_controller_test.rb.erb", 
                   "test/functional/admin/#{model.name.tableize}_controller_test.rb", 
                   :assigns => { :model => model.name }

      end

      ##
      # Generate controllers for tableless models.
      #

      Typus.resources.each do |resource|

        m.template "auto/resource_controller.rb.erb", 
                   "app/controllers/admin/#{resource.underscore}_controller.rb", 
                   :assigns => { :resource => resource }

        views_folder = "app/views/admin/#{resource.underscore}"
        FileUtils.mkdir_p(views_folder) unless File.directory?(views_folder)
        m.file "auto/index.html.erb", "#{views_folder}/index.html.erb"

      end

      ##
      # Migration file
      #

      m.migration_template 'db/create_typus_users.rb', 'db/migrate', 
                            { :migration_file_name => 'create_typus_users' }

    end

  end

end