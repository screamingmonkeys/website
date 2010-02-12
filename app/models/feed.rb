class Feed
  require 'rss/2.0'
  require 'open-uri'
  require 'htmlentities'
  
  def get_data(url)
    # Default text
    feed_data = "<h2>## Event Details</h2> 
                 <p>Sorry, but we do not have any events scheduled at this time.</p>
                 <p>Please check back later.</p>"
                         
    unless url.empty?
      coder    = HTMLEntities.new
      open(url) do |http|
        response  = http.read
        result    = RSS::Parser.parse(response, false)
        feed_data = "" unless result.items.size == 0
        
        result.items.each do |item| 
          description = coder.decode(item.description)
          feed_data += "<h2>## #{item.title}</h2> <p>#{description}</p> <p>=> <a href='#{item.link}'>view on meetup.com</a></p>"
        end
        puts result
      end
    end
    feed_data
  end
  
end