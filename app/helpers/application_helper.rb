# Methods added to this helper will be available to all templates in the application.
module ApplicationHelper
  def copyright_date
    launch_year   = '2008'
    current_year  = Time.now.year.to_s
  
    launch_year +"-"+ current_year
  end
  
  def bodytag_id
    a = controller.action_name.underscore
    
    #change underscores to spaces and capitalize words in string
    "#{a}".gsub(/_/, '-')
  end
  
  def is_current_tab
    if @tab.permalink == @page.permalink 
      'class="current"'
    else
      ''
    end
  end
end
