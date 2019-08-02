workflow "Push" {
  on = "push"
  resolves = ["composer deploy"]
}

action "composer deploy" {
  uses = "docker://composer:latest",
  runs = "composer",
  args = "install"
}
