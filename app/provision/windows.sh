#!/usr/bin/env bash

PROJECT_NAME=$1
PROJECT_HOSTNAME=$2
PROJECT_ROOT=$3
SERVER_SWAP=$4

sudo apt-get update
sudo apt-get install -y software-properties-common python-software-properties
sudo add-apt-repository -y ppa:ansible/ansible
sudo apt-get update
sudo apt-get install -y ansible

sudo cp ${PROJECT_ROOT}/app/provision/inventories/development /etc/ansible/hosts -f
sudo chown root:root /etc/ansible/hosts
sudo chmod 0666 /etc/ansible/hosts
cat ${PROJECT_ROOT}/app/provision/files/authorized_keys >> $HOME/.ssh/authorized_keys

ansible-playbook ${PROJECT_ROOT}/app/provision/playbook.yml --connection=local \
    --extra-vars "project_name=$PROJECT_NAME project_hostname=$PROJECT_HOSTNAME project_root=$PROJECT_ROOT server_swap=$SERVER_SWAP"
