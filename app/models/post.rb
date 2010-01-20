class Post < ActiveRecord::Base
  validates_presence_of :title
  
  def typus_name
    title
  end
end