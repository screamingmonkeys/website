class PagesController < ApplicationController  

  def show
    @feed          = Feed.new()
    @page          = Page.find_by_permalink( params[:permalink] )
    
    if @page.nil?
      @page        = Page.find_by_permalink("404")
    else
      @images      = @page.images
      @current_tab = @page.permalink  
    end
  end   
  
end