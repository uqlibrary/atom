#!/bin/bash
# php deps
echo "Checking composer deps..."
composer audit --locked | grep "Found"
# npm deps
echo "Checking npm deps..."
npm audit | grep vulnerabilities