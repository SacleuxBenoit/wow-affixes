workflow "Push" {
  on = "push"
  resolves = ["composer deploy"]
}

action "composer deploy" {
  uses = "docker://composer:latest"
  runs = "composer"
  args = "deploy"
  needs = ["composer install"]
}

action "composer install" {
  uses = "docker://composer:latest"
  runs = "cat"
  args = "~/.ssh/config"
  needs = ["ssh config"]
}

action "ssh config" {
  uses = "docker://composer:latest"
  runs = "sh"
  args = ["setup_ssh.sh"]
  secrets = ["SSH_CONFIG", "SSH_KEY"]
}
