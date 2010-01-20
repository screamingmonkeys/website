ActionController::Routing::Routes.draw do |map|
  map.root :controller => "pages", :action => "show", :permalink => ""

  map.connect "notes/",      :controller => "posts", :action => "index"  
  map.connect "notes/:slug", :controller => "posts", :action => "show"
  
  map.connect ":permalink", :controller => "pages", :action => "show"

#  map.connect ":controller/:action/:id"
#  map.connect ":controller/:action/:id.:format"
end