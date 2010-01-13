# Methods added to this helper will be available to all templates in the application.
module ApplicationHelper
  def bodytag_id
    @page.permalink
  end
  
  def is_current_tab
    @tab.permalink == @page.permalink ? 'class="current"' : ''
  end
end
