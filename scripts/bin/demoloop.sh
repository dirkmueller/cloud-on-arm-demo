#!/bin/bash



while true; do
    count=$(kubectl get rc/nginx  | cut -b 21-25 | tail -n 1)
    echo $count
    curl "http://192.168.122.2/media/k8s/set.php?set=$count"
    sleep 0.2
done
