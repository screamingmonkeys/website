class RenameSeoKeywordOnPosts < ActiveRecord::Migration
  def self.up
    rename_column :posts, :seo_keyword, :seo_keywords 
  end

  def self.down
    rename_column :posts, :seo_keywords, :seo_keyword 
  end
end
