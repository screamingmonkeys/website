class PagesController < ApplicationController  
  def index
    @page = Page.find_by_permalink( params[:permalink] )
    @slide = @page.slides.first unless @page.nil?
  end
end