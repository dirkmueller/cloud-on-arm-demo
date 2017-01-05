#!/bin/bash

kubectl --namespace kube-system delete svc/kubernetes-dashboard --grace-period=0
kubectl --namespace kube-system delete deployment/kubernetes-dashboard --grace-period=0

for pod in $(kubectl get pods --namespace kube-system | grep kubernetes-dashboard | awk '{print $1}'); do
   kubectl --namespace kube-system delete pods/$pod
done
