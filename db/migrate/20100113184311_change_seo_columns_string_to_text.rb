class ChangeSeoColumnsStringToText < ActiveRecord::Migration
  def self.up
    change_column :pages, :seo_description, :text
    change_column :pages, :seo_keywords, :text
  end

  def self.down
    change_column :pages, :seo_description, :string
    change_column :pages, :seo_keywords, :string
  end
end
