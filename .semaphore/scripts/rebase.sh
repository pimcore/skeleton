#!/usr/bin/env bash
set -x

cat /home/semaphore/${DEPLOY_APP}/.semaphore/${CLUSTER_NAMESPACE}/branches | while read line || [[ -n $line ]];
do
  git merge origin/$line ${SEMAPHORE_GIT_BRANCH};
done