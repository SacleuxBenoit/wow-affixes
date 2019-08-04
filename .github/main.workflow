workflow "Push" {
  on = "push"
  resolves = ["sh deploy"]
}

action "sh deploy" {
  uses = "docker://composer:latest"
  runs = "sh"
  args = ["./github_deploy.sh"]
  secrets = ["SSH_CONFIG", "SSH_KEY", "SSH_HOST"]
}
