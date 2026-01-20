#!/usr/bin/env bash

BUNDLES=$(
    runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:list --json | \
    php -r '
      $bundles = json_decode(stream_get_contents(STDIN), true);
      $toInstall = [];
      foreach($bundles as $b) {
        if ($b["Enabled"] == true && 
            $b["Installed"] == false && 
            $b["Installable"] == true) {
          $toInstall[] = $b["Bundle"];
        }
      }
      echo implode(" ", $toInstall);
    '
)

if [ -z "${BUNDLES}" ]; then
    echo "No bundles to install"
else
    for BUNDLE in ${BUNDLES}; do
       echo "Installing bundle: ${BUNDLE}"
       runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install "${BUNDLE}" --no-interaction --no-cache-clear
    done

    echo "Manually clearing cache..."
    runuser -u www-data -- /var/www/html/bin/console cache:clear --no-interaction
fi
