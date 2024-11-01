#!/usr/bin/env bash

set -Eeuo pipefail

# Set env variables in order to experience a behaviour closer to what happens
# in the CI locally. It should not hurt to set those in the CI as the CI should
# contain those values.
export CI=1
export COMPOSER_NO_INTERACTION=1

readonly ORIGINAL_WORKING_DIR=$(pwd)

trap "cd ${ORIGINAL_WORKING_DIR}" err exit

# Change to script directory
cd "$(dirname "$0")"

# Ensure we have a clean state
rm -rf actual.txt || true
rm -rf .composer || true
rm -rf composer.lock || true
rm -rf vendor || true
rm -rf vendor-bin/*/composer.lock || true
rm -rf vendor-bin/*/vendor || true
rm -rf vendor-bin/*/.composer || true

composer update

# Actual command to execute the test itself
php root_root.php | tee >> actual.txt
php root_vendorbin.php | tee >> actual.txt
php vendor-bin/tool/root_root.php | tee >> actual.txt
php vendor-bin/tool/root_vendorbin.php | tee >> actual.txt
