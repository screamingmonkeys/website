class Post < ActiveRecord::Base
  acts_as_textiled :content
  
  default_scope :order => "created_at DESC"
  named_scope :recent_ten, :order => "created_at DESC LIMIT 10"
end