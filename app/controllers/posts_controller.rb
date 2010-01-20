class PostsController < ApplicationController
  def index
    @posts       = Post.all    
    @current_tab = 'notes'
  end
  
  def show
    @posts       = Post.all  
    @post        = Post.find_by_slug( params[:slug] )
    @current_tab = 'notes'
    
    if @post.nil?
      @post = Page.find_by_permalink("404")
    end
  end
end