class AddSeoToPosts < ActiveRecord::Migration
  def self.up
    add_column :posts, :seo_keyword, :text
    add_column :posts, :seo_description, :text
  end

  def self.down
    remove_column :posts, :seo_keyword
    remove_column :posts, :seo_description
  end
end
