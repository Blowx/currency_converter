#!/bin/bash

if [ "$1" = "" ]; then
  echo "Empty command => EXIT"
  exit 0
fi

DIRPATH="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
if [ "$3" = "" ]; then
  if [ "$2" = "" ]; then
    COMMAND="$1"
  else
    COMMAND="$1 $2"
  fi
else
  COMMAND="$1 $2 $3"
fi

STARTER="php $DIRPATH/yii $COMMAND"

if ! ps ax | grep -v grep | grep -v api.sh | grep "$STARTER"; then
  $STARTER >/tmp/alarm_start.log 2>&1 &
  exit 0
fi
