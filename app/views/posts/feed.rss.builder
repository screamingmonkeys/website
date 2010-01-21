xml.instruct! :xml, :version => "1.0"
xml.rss :version => "2.0" do
  xml.channel do
    xml.title "Screaming Monkeys Event Notes"
    xml.description "Event notes from meetups of the Screaming Monkeys Web Guild."
    xml.link "/notes"

    for post in @posts
      xml.item do
        xml.title post.title
        xml.description post.content
        xml.pubDate post.created_at.to_s(:rfc822)
        xml.link post.slug
      end
    end
  end
end