class Page < ActiveRecord::Base
  default_scope :order => 'sort_by DESC'
  
  def typus_name
    title
  end
end