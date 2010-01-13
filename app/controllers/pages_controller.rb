class PagesController < ApplicationController  
  require 'rss/2.0'
  require 'open-uri'
  require 'htmlentities'

  def show
    @tabs   = Page.all
    @page   = Page.find_by_permalink( params[:permalink] )
    
    if @page.nil?
      render :file => "#{RAILS_ROOT}/public/404.html", :layout => false, :status => 404
    else
    
      @images = @page.images
      @rss    = ''
   
      if @page.title == 'Schedule'
        coder = HTMLEntities.new
        feed_url = 'http://api.meetup.com/events.rss/?zip=46815&group_urlname=screamingmonkeys&key=555f7b666820756c1a382f13a6b2b7e'

        open(feed_url) do |http|
          response = http.read
          result   = RSS::Parser.parse(response, false)
          result.items.each do |item| 
            description = coder.decode(item.description)
            @rss += "<h2>## #{item.title}</h2> <p>#{description}</p> <p>=> <a href='#{item.link}'>view on meetup.com</a></p>"
          end
        end
        @rss = '<div id="rss">' + @rss + '</div>'
       end
     end
  end
end