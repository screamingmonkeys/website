class RenameBodyToContentOnPages < ActiveRecord::Migration
  def self.up
    rename_column :pages, :body, :content 
  end

  def self.down
    rename_column :pages, :content, :body 
  end
end
