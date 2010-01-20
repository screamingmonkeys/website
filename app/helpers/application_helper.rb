# Methods added to this helper will be available to all templates in the application.
module ApplicationHelper
  
  def page_nav
    html  = ''
    @tabs = Page.all

    @tabs.each do |@tab|
      unless @tab.permalink == '404'
	      html += "<li><a href='/#{@tab.permalink}' #{is_current_tab}>#{@tab.title}</a></li>"
	    end
	  end
    "<ul>#{html}</ul>"
  end
  
  def is_current_tab
    @tab.permalink == @current_tab ? 'class="current"' : ''
  end
  
end