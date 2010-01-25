class RSS
  
  initializer
    url  = ''
    html = ''
  end
  
  self.feed (url)  
    unless url.empty?
      coder    = HTMLEntities.new
      open(url) do |http|
        response = http.read
        result   = RSS::Parser.parse(response, false)
      
        result.items.each do |item| 
          description = coder.decode(item.description)
          html += "<h2>## #{item.title}</h2> <p>#{description}</p> <p>=> <a href='#{item.link}'>view on meetup.com</a></p>"
        end
      end
    end
    html 
  end
  
end