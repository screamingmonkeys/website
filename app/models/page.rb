class Page < ActiveRecord::Base
  default_scope :order => 'sort_by DESC'
end