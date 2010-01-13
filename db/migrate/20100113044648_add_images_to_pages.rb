class AddImagesToPages < ActiveRecord::Migration
  def self.up
    add_column :pages, :images, :text
  end

  def self.down
    remove_column :pages, :images
  end
end
