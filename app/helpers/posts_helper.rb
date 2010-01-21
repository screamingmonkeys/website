module PostsHelper
  def snippet (text, wordcount, separator="...")
    text.split[0..(wordcount-1)].join(" ") + (text.split.size > wordcount ? separator : "") 
  end
end
