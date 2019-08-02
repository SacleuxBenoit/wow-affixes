#!/bin/sh

mkdir -p ~/.ssh
touch ~/.ssh/known_hosts

echo "$SSH_CONFIG" > ~/.ssh/config
echo "$SSH_KEY" > ~/.ssh/deploy_key

chmod 700 ~/.ssh
chmod 600 ~/.ssh/deploy_key
chmod 600 ~/.ssh/known_hosts

eval $(ssh-agent)
ssh-add ~/.ssh/deploy_key

