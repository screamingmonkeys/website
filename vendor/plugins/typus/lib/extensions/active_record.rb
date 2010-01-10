class ActiveRecord::Base

  def to_dom(*args)

    options = args.extract_options!
    display_id = new_record? ? 'new' : id

    [ options[:prefix], 
      self.class.name.underscore, 
      display_id, 
      options[:suffix] ].compact.join('_')

  end

  ##
  # We had:
  #
  #   def typus_name
  #     respond_to?(:name) ? name : "#{self.class}##{id}"
  #   end
  #
  # ActiveScaffold uses `to_label`, which makes more sense. We want 
  # to keep compatibility with old versions of Typus. The prefered method 
  # is `to_label` and `typus_name` will be deprecated in the next months.
  #
  def to_label
    [ :typus_name, :name ].each do |attribute|
      return send(attribute).to_s if respond_to?(attribute)
    end
    return "#{self.class}##{id}"
  end

end
