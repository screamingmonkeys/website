ActionController::Routing::Routes.draw do |map|
  map.root :controller => "home"

  map.connect ':permalink', :controller => "pages"

  map.connect ':controller/:action/:id'
  map.connect ':controller/:action/:id.:format'
end