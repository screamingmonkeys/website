class Page < ActiveRecord::Base
  def typus_name
    title
  end
end