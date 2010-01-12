class AddSortByToPages < ActiveRecord::Migration
  def self.up
    add_column :pages, :sort_by, :integer
  end

  def self.down
    remove_column :pages, :sort_by
  end
end
