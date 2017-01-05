#!/bin/bash

current=50
while true; do 

  if [ $(($RANDOM%100)) -ge 50 ]; then
    add=$((RANDOM%3))
  else
    add=-$(($RANDOM%3))
  fi
  current=$(($current+$add))
  if [ $current -gt 180 ]; then
    current=180
  fi
  if [ $current -lt 10 ]; then
    current=10
  fi
 
  kubectl scale --replicas $current rc/nginx; sleep 4;  

done
