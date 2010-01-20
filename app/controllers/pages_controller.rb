class PagesController < ApplicationController  
  require 'rss/2.0'
  require 'open-uri'
  require 'htmlentities'

  def show
    @page          = Page.find_by_permalink( params[:permalink] )
    
    if @page.nil?
      @page        = Page.find_by_permalink("404")
    else
      @images      = @page.images
      @current_tab = @page.permalink  
    end
  end   
end