class Post < ActiveRecord::Base
  default_scope :order => 'sort_by created_at DESC'
end