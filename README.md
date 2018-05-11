# Linux-Deploy-System

# What is it?
This is a Linux Package deployment system I wrote in college. Its intended use is to automatically deliver system and application packages to other servers or virtual machines within your network.


# How does it work?
It is intended to be setup and used within a three tiered server framework (Development, Quality Assurance and Production.) In addition, there is another server(Orchestration) used in this system which is designed to handle communication between the other three servers using RabbitMQ via AMQP(Advanced Messaging Queueing Protocol). Whenever there is a new version available for your files or application in your development server, this system will automatically create a package of all your files and then deploy them to a desired location on your Quality Assurance server for testing before being sent to the production server for live use.

# What can it be used for?
This deployment system is designed for businesses and development teams who want to ensure maximum uptime for their applications while minimizing potential bugs or unwanted code getting into their live production applications.

# Disclaimer
This project is still under construction and code or features may change or vary at any point.
