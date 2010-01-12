class Page < ActiveRecord::Base
  default_scope :order => 'sort_by'
  
  def typus_name
    title
  end
end