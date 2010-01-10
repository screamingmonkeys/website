class CreatePages < ActiveRecord::Migration
  def self.up
    create_table :pages do |t|
      t.string :permalink
      t.string :title
      t.text :body
      t.string :seo_keywords
      t.string :seo_description
      t.timestamps
    end
  end

  def self.down
    drop_table :pages
  end
end
