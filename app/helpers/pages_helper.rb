module PagesHelper
  
  def page_images
    html = ''
    @page.images.split(',').each do |img|
       html += "<li><img src='#{img}' alt='' class='border' /></li>"
    end
    "<ul>#{html}</ul>"
  end
  
  def rss_feed 
     # Pull RSS feed and parse
     if @page.permalink == "schedule"
       schedule_feed = @feed.get_data("http://api.meetup.com/events.rss/?zip=46815&group_urlname=screamingmonkeys&key=555f7b666820756c1a382f13a6b2b7e")

       "<div id='rss'>#{schedule_feed}</div>"
     end
   end
   
end