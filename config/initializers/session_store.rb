# Be sure to restart your server when you modify this file.

# Your secret key for verifying cookie session data integrity.
# If you change this key, all old sessions will become invalid!
# Make sure the secret is at least 30 characters and all random, 
# no regular words or you'll be exposed to dictionary attacks.
ActionController::Base.session = {
  :key         => '_smwg_session',
  :secret      => 'a2aa1903d6512412d883cbe316a95120cfa5d1ec8b0b3c6e389ef12a3898424c196f6f019518ec44277785b1a105cb10c4cb0f0ed2a3c2aa1f396aa336e7d7d8'
}

# Use the database for sessions instead of the cookie-based default,
# which shouldn't be used to store highly confidential information
# (create the session table with "rake db:sessions:create")
# ActionController::Base.session_store = :active_record_store
