The Hub manages Nodes that can perform
  "role": "hub",
  "maxSession": $GRID_MAX_SESSION,
  "newSessionWaitTimeout": $GRID_NEW_SESSION_WAIT_TIMEOUT,
  "capabilityMatcher": "org.openqa.grid.internal.utils.DefaultCapabilityMatcher",
  "throwOnCapabilityNotPresent": $GRID_THROW_ON_CAPABILITY_NOT_PRESENT,
  "jettyMaxThreads": $GRID_JETTY_MAX_THREADS,
  "cleanUpCycle": $GRID_CLEAN_UP_CYCLE,
  "browserTimeout": $GRID_BROWSER_TIMEOUT,
  "timeout": $GRID_TIMEOUT,
  "debug": $GRID_DEBUG tests. When it receives a test to be executed, that responsibility is delegated to a Node that can do so.
