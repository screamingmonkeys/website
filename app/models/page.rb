class Page < ActiveRecord::Base
  acts_as_textiled :content
  default_scope :order => 'sort_by DESC'
end