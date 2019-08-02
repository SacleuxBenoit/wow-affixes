workflow "Push" {
  on = "push"
  resolves = ["composer deploy"]
}

action "composer install" {
  uses = "docker://composer:latest"
  runs = "composer"
  args = "install"
}

action "composer deploy" {
  uses = "docker://composer:latest"
  runs = "composer"
  args = "deploy"
  needs = ["composer install", "ssh config"]
}

action "ssh config" {
  uses = "docker://composer:latest"
  runs = "sh"
  args = ["setup_ssh.sh"]
  secrets = [
    "SSH_CONFIG",
    "PRIVATE_KEY"
  ]
}
