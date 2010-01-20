class PostsController < ApplicationController
  def show
    @post = Posts.all
  end
end