# Traps
Plugins to add traps

## Config

```YAML
---
# Welcome to the plugin : Traps v1.0.0
# Infinite configuration !

# -------

# messages types:
# - tip
# - message
# - subtitle
# - title
# - popup

# -------

# all effects (PocketMine-MP):

# SPEED = 1
# SLOWNESS = 2
# HASTE = 3
# FATIGUE = 4
# STRENGTH = 5
# INSTANT HEALTH = 6
# INSTANT DAMAGE = 7
# JUMP BOOST = 8
# NAUSEA = 9
# REGENERATION = 10
# RESISTANCE = 11
# FIRE RESISTANCE = 12
# WATER BREATHING = 13
# INVISIBILITY = 14
# BLINDNESS = 15
# NIGHT VISION = 16
# HUNGER = 17
# WEAKNESS = 18
# POISON = 19
# WITHER = 20
# HEALTH BOOST = 21
# ABSORPTION = 22
# SATURATION = 23
# LEVITATION = 24
# FATAL POISON = 25
# CONDUIT POWER = 26


traps:
  "4:0":
    damages: 2
    message:
      type: popup # tip | popup | subtitle | title | message
      enable: true
      content: "§6- §eYou were set up !"
    effects:
      15:  # id effect
        duration: 20 # 20 seconds
        niveau: 1 # lvl 1
        particles: false
...
```
