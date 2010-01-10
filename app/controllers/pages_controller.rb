class PagesController < ApplicationController  
  def index
    @page = Page.find_by_permalink( params[:permalink] )
  end
end