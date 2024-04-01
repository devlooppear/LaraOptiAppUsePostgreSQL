# DigitalOcean Kubernetes Cluster Management README

This guide provides step-by-step instructions on how to manage your DigitalOcean Kubernetes cluster using kubectl and doctl. Based in what i do in my machine, i use Linux, maybe the proccess with you can be different.

## Installation

Installing doctl using Snap (Ubuntu or supported operating systems)
Run the following command to install the latest version of doctl using Snap:

```bash
sudo snap install doctl
```

Grant additional permissions to doctl for certain commands:

For kubectl integration:

```bash
sudo snap connect doctl:kube-config
```

For doctl compute ssh command:

```bash
sudo snap connect doctl:ssh-keys :ssh-keys
```

For doctl registry login command:

```bash
sudo snap connect doctl:dot-docker
```

Verification and Connectivity
kubectl Commands:
List Contexts:

```bash
kubectl config get-contexts
```

Cluster Information:

```bash
kubectl cluster-info
```

Kubernetes Version:

```bash
kubectl version
```

List Nodes:

```bash
kubectl get nodes
```

Help:

```bash
kubectl help
```

doctl Commands:
List Kubernetes Clusters:

```bash
doctl kubernetes cluster list
```

View Kubernetes Cluster Information:

```bash
doctl kubernetes cluster get <cluster-name>
```

List Kubernetes Nodes:

```bash
doctl kubernetes cluster kubeconfig save <cluster-id>
```

kubectl get nodes
List Kubernetes Regions:

```bash
doctl kubernetes options regions
```

List Kubernetes Versions:

```bash
doctl kubernetes options versions
```

Additional Resources
Kubectl Official Documentation
Doctl Official Documentation

## To apply the .yaml files in the k8s:

```bash
kubectl apply -f service.yaml
```

and

```bash
kubectl apply -f deployment.yaml
```

## To check your nodes:

```bash
kubectl get svc
```

## Deleting all in k8s

```bash
kubectl delete pod,service,deployment,statefulset,daemonset,replicaset,job,cronjob --all
```
