#!/bin/bash

# Certain secrets cause problems with Pimcore when used as files - this script converts them to env vars, and then containers can source this script at startup.
# IMPORTANT: Only use this for secrets that must be converted to env vars. For all other secrets, continue to use them as files.
export PIMCORE_ENCRYPTION_SECRET=$(cat /run/secrets/pimcore-encryption-secret 2>/dev/null || echo "")
export PIMCORE_INSTANCE_IDENTIFIER=$(cat /run/secrets/pimcore-instance-identifier 2>/dev/null || echo "")
export PIMCORE_PRODUCT_KEY=$(cat /run/secrets/pimcore-product-key 2>/dev/null || echo "")