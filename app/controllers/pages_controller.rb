class PagesController < ApplicationController  
  def show
    @page   = Page.find_by_permalink( params[:permalink] )
    @tabs   = Page.all
    @images = @page.images
  end
end