class PostsController < ApplicationController
  def index    
    @current_tab  = 'notes'
    @page         = Page.find_by_permalink( @current_tab )
    @posts        = Post.paginate :page => params[:page], :order => 'created_at DESC', :per_page => 10
  end
  
  def show
    @post_list    = Post.recent_ten
    @post         = Post.find_by_slug( params[:slug] )
    @current_tab  = 'notes'
    
    if @post.nil?
      @post = Page.find_by_permalink("404")
    end
  end
  
  def feed
    @posts = Post.all
    
    respond_to do |format|
      format.html
      format.rss  { render :layout => false }
    end
  end
end