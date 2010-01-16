class PagesController < ApplicationController  
  require 'rss/2.0'
  require 'open-uri'
  require 'htmlentities'

  def show
    @tabs   = Page.all
    @page   = Page.find_by_permalink( params[:permalink] )
    
    unless @page.nil?
      @images = @page.images
    else  
      @page = Page.find_by_permalink("404")
    end
  end   
end