import torch

print(torch.cuda.is_available())
# Should output: True

print(torch.cuda.get_device_name(0))
# Outputs your GPU model (e.g., 'NVIDIA GeForce RTX 4070')
