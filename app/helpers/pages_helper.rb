module PagesHelper
  def page_nav
    html = ''
    @tabs.each do |@tab|
      unless @tab.permalink == '404'
	      html += "<li><a href='/#{@tab.permalink}' #{is_current_tab}>#{@tab.title}</a></li>"
	    end
	  end
    "<ul>#{html}</ul>"
  end
  
  def page_images
    html = ''
    @page.images.split(',').each do |img|
       html += "<li><img src='#{img}' alt='' class='border' /></li>"
    end
    "<ul>#{html}</ul>"
  end
  
  def rss_feed 
     # Default text
     html = "<h2>## Event Details</h2> 
           <p>Sorry, but we do not have any events scheduled at this time.</p>
           <p>Please check back later.</p>"

     # Pull RSS feed and parse
     if @page.permalink == "schedule"
       coder    = HTMLEntities.new
       feed_url = "http://api.meetup.com/events.rss/?zip=46815&group_urlname=screamingmonkeys&key=555f7b666820756c1a382f13a6b2b7e"

       open(feed_url) do |http|
         response = http.read
         result   = RSS::Parser.parse(response, false)
         result.items.each do |item| 
           description = coder.decode(item.description)
           html += "<h2>## #{item.title}</h2> <p>#{description}</p> <p>=> <a href='#{item.link}'>view on meetup.com</a></p>"
         end
       end 
           
       "<div id='rss'>#{html}</div>"
     end
   end
end