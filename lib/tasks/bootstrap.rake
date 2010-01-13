# *****************************************
#  Bootstrap an app DB, loading up sample
#  data and performing any db population
#  via Faker tasks (db:populate:all)
#
#  Comment out the db:populate line if you
#  don't have any population tasks and only
#  need to erase/reload the db from
#  migrations and sample data
#  
#  Inspired by the wonderful Spree project
# *****************************************
 
namespace :db do
  desc "Migrate schema to version 0 and back up again. WARNING: Destroys all data in tables!!"
  task :remigrate => :environment do
    require 'highline/import'       
    if ENV['SKIP_NAG'] or agree("This task will destroy any data in the database. Are you sure you want to \ncontinue? [yn] ")
      # Drop all tables
      ActiveRecord::Base.connection.tables.each { |t| ActiveRecord::Base.connection.drop_table t }
      # Migrate upward 
      Rake::Task["db:migrate"].invok
      # Dump the schema
      Rake::Task["db:schema:dump"].invoke
    else
      say "Task cancelled."
      exit
    end
  end
 
  desc 'Load the sample data from db/sample'  
  task :sample => :environment do
    require 'active_record/fixtures'
    Dir.glob(File.join(RAILS_ROOT, "db", 'sample', '*.{yml}')).each do |fixture_file|
      Fixtures.create_fixtures("#{RAILS_ROOT}/db/sample", File.basename(fixture_file, '.*'))
    end
  end
 
  desc 'Erase and remigrate database with bootstrap data. Defaults to development database.  Set RAILS_ENV to override.'
  task :bootstrap => :environment do
    require 'highline/import'       
    # remigrate unless production mode (as saftey check)
    if %w[staging demo development test].include? RAILS_ENV 
      if ENV['AUTO_ACCEPT'] or agree("This task will destroy any data in the database. Are you sure you want to \ncontinue? [yn] ")
        ENV['SKIP_NAG'] = 'yes'
        Rake::Task["db:remigrate"].invoke
      else
        say "Task cancelled."
        exit
      end
      Rake::Task["db:sample"].invoke        # Pull in YML data (mostly "real" data)
      Rake::Task["db:populate:all"].invoke  # Faker populate the rest
    else 
      say "ERROR: Cannot bootstrap in production mode"
      exit
    end
  end
end