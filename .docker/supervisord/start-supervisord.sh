#!/bin/bash
source /etc/profile.d/secrets-to-env-vars.sh
exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf