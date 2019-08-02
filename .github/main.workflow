workflow "Push" {
  on = "push"
  resolves = ["composer deploy"]
}

action "sh deploy" {
  uses = "docker://composer:latest"
  runs = "sh"
  args = ["./github/deploy.sh"]
  secrets = ["SSH_CONFIG", "SSH_KEY"]
}
