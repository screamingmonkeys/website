class Post < ActiveRecord::Base
  default_scope :order => "created_at DESC"
  named_scope :recent_ten, :order => "created_at DESC LIMIT 10"
end